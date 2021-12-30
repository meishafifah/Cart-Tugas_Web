<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        //mengaktifkan session CI pengganti session_start();
        $this->session = \Config\Services::session();
    }

    private $arr_menu = [
        [
            'nama' => 'List Barang',
            'link' => 'produk',
        ],
        [
            'nama' => 'Form Inputan Barang',
            'link' => 'produk/form',
        ],
        [
            'nama' => 'Keranjang Belanja',
            'link' => 'keranjang',
        ],
    ];

    protected function get_menu()
    {
        $html_kode = '';

        foreach ($this->arr_menu as $key => $value) {
            $html_kode .= '<a href="'.base_url($value['link']).'">'.$value['nama'].'</a> ';
        }

        return $html_kode;
    }

    protected function load_template($data_utama, $data_add)
    {
        $data_view = $data_utama;

        $data_view['add_data'] = $data_add;
        $data_view['menu'] = $this->get_menu();

        return view('template/front', $data_view);
    }
}
