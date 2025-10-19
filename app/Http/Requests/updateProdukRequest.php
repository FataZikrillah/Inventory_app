<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => 'required|unique:produks,nama_produk,' . $this->produk->id,
            'deskripsi_produk' => 'nullable|string',
            'kategori_produk_id' => 'required|exists:kategori_produks,id', 
        ];
    }

    public function messages()
    {
        return [
            'nama_produk.required' => 'Nama Produk Harus Diisi',
            'nama_produk.unique' => 'Nama Produk Sudah Ada',
            'kategori_produk_id.required' => 'Kategori Produk Harus Diisi',
            'kategori_produk_id.exists' => 'Kategori Produk Tidak Ditemukan',
        ];
    }
}
