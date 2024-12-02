<?php

namespace App\Http\Controllers;

use App\Http\DTO\Guest\StoreGuest;
use App\Http\DTO\Guest\UpdateGuest;
use App\Http\Helpers\ResponseHelper;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Resources\GuestResource;
use App\Models\Guest;
use App\Services\IGuestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class GuestController extends Controller
{
    public function __construct(
        private readonly IGuestService $guestService,
    ) {}

    public function index(): JsonResponse
    {
        return ResponseHelper::success(GuestResource::collection(Guest::all()));
    }

    public function store(StoreGuestRequest $request): JsonResponse
    {
        $response = $this->guestService->store(StoreGuest::from($request->all()));

        return ResponseHelper::success($response, Response::HTTP_CREATED);
    }

    public function update(StoreGuestRequest $request, Guest $guest): JsonResponse
    {
        $response = $this->guestService->update(
            $guest,
            UpdateGuest::from($request->all() + ['id' => $guest->getKey()])
        );

        return ResponseHelper::success($response);
    }

    public function show(Guest $guest): JsonResponse
    {
        return ResponseHelper::success(GuestResource::make($guest));
    }

    public function destroy(Guest $guest): JsonResponse
    {
        $this->guestService->delete($guest);

        return ResponseHelper::success();
    }
}
