<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\SiteList;
use http\Env\Request;
use Illuminate\Support\Facades\Http;

class RankWebsite
{
    protected $apiToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiToken = config('services.ranklord_api_key');
        $this->apiUrl   = 'https://getranklord.com/wp-json/ranklord/v1/websites';
    }

    public function updateWebsiteRank()
    {
        try {
            $response = Http::withHeaders(['ranklord-api-key' => $this->apiToken])->get("{$this->apiUrl}");
            if ($response->successful()) {
                $dataList    = (object)$response->json();
                $currentDate = Carbon::now()->toDateString();

                if ($dataList->success && !empty($dataList->data)) {
                    foreach ($dataList->data as $row) {
                        $row = (object)$row;
                        SiteList::where('api_site_id', $row->id)
                            ->where('updated_at', '!=', $currentDate)
                            ->update([
                                'da'              => $row->moz_da,
                                'pa'              => $row->moz_pa,
                                'dr'              => $row->ahref_dr,
                                'ahref_rank'      => $row->ahref_rank,
                                'traffic'         => $row->ahref_traffic,
                                'organic_keyword' => $row->ahref_keywords,
                            ]);
                    }

                    return $dataList->message;
                } else {
                    return 'Failed to fetch resources';
                }
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'success' => false]);
        }
    }

    public function updateSingleWebsiteRank($id)
    {
        try {

            if (empty($id)) {
                throw new \InvalidArgumentException('The "id" parameter is required.');
            }

            $response = Http::withHeaders(['ranklord-api-key' => $this->apiToken])->get("{$this->apiUrl}/{$id}");

            if ($response->successful()) {
                $dataList = (object)$response->json();

                if ($dataList->success && !empty($dataList->data)) {

                    $siteInfo = (object)$dataList->data;

                    SiteList::where('api_site_id', $id)
                        ->update([
                            'da'              => $siteInfo->moz_da,
                            'pa'              => $siteInfo->moz_pa,
                            'dr'              => $siteInfo->ahref_dr,
                            'ahref_rank'      => $siteInfo->ahref_rank,
                            'traffic'         => $siteInfo->ahref_traffic,
                            'organic_keyword' => $siteInfo->ahref_keywords,
                        ]);


                    return $dataList->message;
                }

            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store($website_url)
    {
        try {

            if (empty($website_url)) {
                throw new \InvalidArgumentException('The "website_url" parameter is required.');
            }

            $data     = ['website_url' => $website_url];
            $response = Http::withHeaders(['ranklord-api-key' => $this->apiToken])->post($this->apiUrl, $data);
            if ($response->successful()) {
                return (object)$response->json();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($id, $website_url)
    {
        try {

            if (empty($id)) {
                throw new \InvalidArgumentException('The "id" parameter is required.');
            }

            if (empty($website_url)) {
                throw new \InvalidArgumentException('The "website_url" parameter is required.');
            }

            $data     = ['website_url' => $website_url];
            $response = Http::withHeaders(['ranklord-api-key' => $this->apiToken])->put("{$this->apiUrl}/{$id}", $data);
            if ($response->successful()) {
                return (object)$response->json();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {

            if (empty($id)) {
                throw new \InvalidArgumentException('The "id" parameter is required.');
            }

            $response = Http::withHeaders(['ranklord-api-key' => $this->apiToken])->delete("{$this->apiUrl}/{$id}");

            if ($response->successful()) {
                return (object)$response->json();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function checkLicence($host)
    {
        try {
            $response = Http::withHeaders([
                'ranklord-api-key' => $this->apiToken,
                'domain'           => $host
            ])->get("https://getranklord.com/wp-json/ranklord/v1/subscription");

            if ($response->successful()) {
                return  (object)$response->json();
            }

        } catch (\Exception $e) {
            abort(404);
        }
    }
}
