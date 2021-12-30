<?php 
    namespace App\Models;
    use CodeIgniter\Model;
    class ProdukModel extends Model
    {
        protected $table = 'produk';
        protected $primaryKey = 'id_produk';

        protected $useAutoIncrement = true;

        protected $returnType = 'array';

        protected $allowedFields = ['kode_produk', 'nama_produk', 'stok', 'harga', 'deskripsi'];

        protected $validationRules = [
            'kode_produk' => 'required|is_unique[produk.kode_produk,id_produk,{id_produk}]'
        ];

        protected $validationMessages = [
            'kode_produk' => [
                'is_unique' => 'Maaf, Kode Produk Sudah Ada'
            ],
        ];
    }
?>