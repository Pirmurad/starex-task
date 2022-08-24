<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PackageRequest;
use App\Jobs\PackageProcessJob;
use App\Models\Package;
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

            if (!is_null($user)) {
                $package_detail = $request['data'];
                foreach (array_chunk($package_detail, 100) as $data) {
                    foreach ($data as $package) {
                        PackageProcessJob::dispatch($user, $package);
                    }
                }

            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
