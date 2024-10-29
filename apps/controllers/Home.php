<?php


class Home extends Controller{
    private $dt;
    private $df;

    public function __construct(){
        $this->dt = $this->loadmodel("barang"); // object class barang
        $this->df = $this->loadmodel("daftarBarang"); // object class daftar barang
    }
    public function index(){
        echo "anda memanggil action index \n";
    }
    public function home($data1, $data2){
        echo "anda memanggil action home dengan data 1 = $data1 dan data2 = $data2 \n";
    }
    public function lihatdata($id){
        $data = $this->df->getDataById($id);

        $this->loadview('template/header',['title'=>'Detail Barang']);
        $this->loadview('home/detailbarang',$data);
        $this->loadview('template/footer');
    }
    public function listbarang(){
        $data = $this->df->getDataAll();

        $this->loadview('template/header',['title'=>'List Barang']);
        $this->loadview('home/listbarang',$data);
        $this->loadview('template/footer');
        
    }

    public function insertBarang(){
        if (!empty($_POST)) {
            if ($this->df->tambahBarang($_POST)) {
                header('Location: '.BASE_URL.'index.php?r=home/listbarang');
                exit;
            }
        }
        $this->loadview('template/header',['title'=>'Insert Barang']);
        $this->loadview('home/insert');
        $this->loadview('template/footer');
    }

    public function updateBarang($id){

        $data = $this->df->getDataById($id);

        if (!empty($_POST)) {
            if ($this->df->updateBarang($_POST)) {
                header('Location: '.BASE_URL.'index.php?r=home/listbarang');
                exit;
            }
        }

        $this->loadview('template/header',['title'=>'Update Barang']);
        $this->loadview('home/update',$data);
        $this->loadview('template/footer');
    }

    public function deleteBarang($id){

        $data = $this->df->getDataById($id);

        
            if ($this->df->hapusBarang($id)) {
                header('Location: '.BASE_URL.'index.php?r=home/listbarang');
                exit;
            }
    }
}
