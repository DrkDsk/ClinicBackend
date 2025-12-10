<?php

namespace App\Services\Contract;

use App\Classes\DTOs\Appointment\CreateAppointmentDTO;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;

interface AppointmentServiceInterface
{
    public function create(CreateAppointmentDTO $appointmentData): Appointment;

    public function getAvailableAppointmentsSchedule(Doctor $doctor, Carbon $date): array;
}
