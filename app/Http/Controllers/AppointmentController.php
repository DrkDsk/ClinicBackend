<?php

namespace App\Http\Controllers;

use App\Factories\CreateAppointmentDTOFactory;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\PaginatorRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\ErrorResource;
use App\Models\Appointment;
use App\Repositories\Contract\AppointmentRepositoryInterface;
use App\Services\Contract\AppointmentServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class AppointmentController extends Controller
{
    public function __construct(
        protected readonly AppointmentServiceInterface    $appointmentService,
        protected readonly AppointmentRepositoryInterface $appointmentRepository)
    {
    }

    public function store(CreateAppointmentRequest $request): ErrorResource|AppointmentResource
    {
        try {

            $appointmentData = CreateAppointmentDTOFactory::fromRequest($request);

            $appointment = $this->appointmentService->create($appointmentData);

            $appointment->load(['doctor', 'patient', 'typeAppointment']);

            return new AppointmentResource($appointment);
        } catch (Throwable $exception) {
            return new ErrorResource(message: $exception->getMessage(), statusCode: 409);
        }
    }

    public function get(PaginatorRequest $request): AnonymousResourceCollection
    {
        $perPage = $request->input('perPage');

        $appointments = $this->appointmentRepository->paginate($perPage, ['doctor.person', 'patient.person', 'typeAppointment']);

        return AppointmentResource::collection($appointments);
    }

    public function show(Appointment $appointment): AppointmentResource
    {
        $appointment->load(['doctor.person', 'patient.person', 'typeAppointment']);

        return new AppointmentResource($appointment);
    }
}
