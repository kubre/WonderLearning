<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $academicYear = \get_academic_year(\today(), $this->school);
        return [
            'student' => [
                'id' => $this->id,
                'name' => $this->name,
                'photo' => \is_null($this->photo) ? null : \secure_url($this->photo),
                'dob_at' => $this->dob_at->format('d-M-Y'),
                'gender' => $this->gender,
                'prn' => $this->prn,
                'father_name' => $this->father_name,
                'father_contact' => $this->father_contact,
                'father_email' => $this->father_email,
                'mother_name' => $this->mother_name,
                'mother_contact' => $this->mother_contact,
                'mother_email' => $this->mother_email,
                'admission_at' => $this->admission->admission_at->format('d-M-Y'),
                'program' => $this->admission->program,
                'discount' => $this->admission->discount,
                'batch' => $this->admission->batch,
                'is_transportation_required' => $this->admission->is_transportation_required,
                'admission_id' => $this->admission->id,
                'division_id' => $this->admission->division->id ?? null,
                'division_title' => $this->admission->division->title ?? '-- No Division Assigned --',
                'kit_assigned' => (bool) $this->admission->assigned_kit,
            ],
            'school' => [
                'id' => $this->school->id,
                'name' => $this->school->name,
                'logo' => \secure_url($this->school->logo),
                'contact' => $this->school->contact,
                'email' => $this->school->email,
                'address' => $this->school->address,
                'academic_start' => $academicYear[0]->format('M-Y'),
                'academic_end' => $academicYear[1]->format('M-Y'),
                'is_suspended' => !\is_null($this->school->is_suspended),
            ],
        ];
    }
}
