<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Carbon::setLocale('es');
        $scheduleAt = $this->scheduled_at;
        $scheduleAtParsed = Carbon::parse($scheduleAt);

        return [
            "id" => $this->id,
            "scheduled_at" => $scheduleAtParsed->translatedFormat('l j \d\e F \d\e Y'),
            "time" => $scheduleAtParsed->translatedFormat('g:i a'),
            "note" => $this->note,
            "doctor" => DoctorResource::make($this->whenLoaded('doctor')),
            "patient" => PatientResource::make($this->whenLoaded('patient')),
            "typeAppointment" => typeAppointmentResource::make($this->whenLoaded('typeAppointment')),
        ];
    }
}
