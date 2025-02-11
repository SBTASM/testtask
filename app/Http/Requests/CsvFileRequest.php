<?php

namespace App\Http\Requests;

use App\Services\CSV;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CsvFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'csv_file.required' => __('File is required!'),
            'csv_file.mimes' => __('Only TXT or CSV files are allowed!'),
            'csv_file.max' => __('File  is too large!'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'csv_file' => ['required', 'mimes:csv,txt', 'file'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->file('csv_file')) {
                $this->handleCustomCsvRequest($validator, $this->file('csv_file'));
            }
        });
    }

    /**
     * @param Validator $validator
     * @param UploadedFile $file
     * @return void
     *
     * Взагалі, по хорошому, ось тут треба фільтрувати країни та інші данні(створивши кастомний валідатор, або правило).
     * Але я не знаю, скільки ресурсу буде у скрита, та не знаю чи є критичним час виконання і що там за файлова система. (задача у нас абстрактна)
     * Так що цей функціонал перекочує в сервіс імпорта. @see CSV::import(),CSV::isAllowedRow(), він один відпрацює швидше
     */
    private function handleCustomCsvRequest(Validator $validator, UploadedFile $file): void
    {
        //Implement filtration.
    }

}
