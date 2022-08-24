<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PackageRequest;
use App\Jobs\PackageProcessJob;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{
    /**
     * @param PackageRequest $request
     * @return JsonResponse
     */


    public function store(PackageRequest $request)
    {
        try {
            $user = request()->user();
            $package_detail = $request['data'];

            if (count($package_detail) <= 1000) {
                foreach (array_chunk($package_detail, 50) as $data) {
                    foreach ($data as $package) {
                        PackageProcessJob::dispatch($user, $package);
                    }
                }
            }else {
                return response()->json(['errors' => ['Paketlərin cəmi 1000 dən artıq ola bilməz!']]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
