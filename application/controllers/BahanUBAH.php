//ubah-kategori
<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-3">
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php } ?>
            <form action="<?= base_url('buku/editKategori'); ?>" method="post">
                <?php
                foreach ($kategori as $k) : ?>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" value="<?= $k['kategori']; ?>" id="kategori" placeholder="Masukkan  kategori" name="kategori">
                        <input type="text" class="form-control form-control-user" value="<?= $k['id']; ?>" id="id" placeholder="Masukkan  id" name="id" hidden>
                    </div>
                <?php

                endforeach; ?>

                <div class="form-group">
                    <button type="resset" class="btn btn-secondary"><i class="fas fa-ban"></i> reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

//kategori
<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-3">
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php } ?>
            <?= $this->session->flashdata('pesan'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#kategoriBaruModal"><i class="fas fafile-alt"></i> Tambah Kategori</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $a = 1;
                    foreach ($kategori as $k) { ?>
                        <tr>
                            <th scope="row"><?= $a++; ?></th>
                            <td><?= $k['kategori']; ?></td>
                            <td>
                                <a href="<?= base_url('buku/ubahkategori/') . $k['id']; ?>" class="badge badge-info"><i class="fas fa-edit"></i> Ubah</a>
                                <a href="<?= base_url('buku/hapuskategori/') . $k['id']; ?>" onclick="return confirm('Kamu yakin akan menghapus <?= $judul . ' ' . $k['kategori']; ?>?');" class="badge badge-danger"><i class="fas fa-trash"></i>Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Tambah kategori baru-->
<div class="modal fade" id="kategoriBaruModal" tabindex="-1" role="dialog" aria-labelledby="kategoriBaruModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriBaruModalLabel">Tambah Kategori</h5>
                <button type="button" class="close" datadismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('buku/tambahKategori'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" value="" id="kategori" placeholder="Masukkan kategori" name="kategori">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Tambah Mneu -->


//Buku
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelBuku');
        cek_login();
    }

    // manajemen kategori
    public function index()
    {
        $data['judul'] = 'Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        $this->form_validation->set_rules('judul_buku', 'Judul Buku', 'required|min_length[3]', [
            'required' => 'Judul Buku harus diisi',
            'min_length' => 'Judul buku terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'id_kategori',
            'Kategori',
            'required',
            [
                'required' => 'Nama pengarang harus diisi',
            ]
        );
        $this->form_validation->set_rules('pengarang', 'Nama Pengarang', 'required|min_length[3]', [
            'required' => 'Nama pengarang harus diisi',
            'min_length' => 'Nama pengarang terlalu pendek'
        ]);
        $this->form_validation->set_rules('penerbit', 'Nama Penerbit', 'required|min_length[3]', [
            'required' => 'Nama penerbit harus diisi',
            'min_length' => 'Nama penerbit terlalu pendek'
        ]);
        $this->form_validation->set_rules('tahun', 'Tahun Terbit', 'required|min_length[3]|max_length[4]|numeric', [
            'required' => 'Tahun terbit harus diisi',
            'min_length' => 'Tahun terbit terlalu pendek',
            'max_length' => 'Tahun terbit terlalu panjang',
            'numeric' => 'Hanya boleh diisi angka'
        ]);
        $this->form_validation->set_rules('isbn', 'Nomor ISBN', 'required|min_length[3]|numeric', [
            'required' => 'Nama ISBN harus diisi',
            'min_length' => 'Nama ISBN terlalu pendek',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric', [
            'required' => 'Stok harus diisi',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        $this->load->library('upload', $config);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/index', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data();
                $gambar = $image['file_name'];
            } else {
                $gambar = '';
            }

            $data = [
                'judul_buku' => $this->input->post('judul_buku', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'pengarang' => $this->input->post('pengarang', true),
                'penerbit' => $this->input->post('penerbit', true),
                'tahun_terbit' => $this->input->post('tahun', true),
                'isbn' => $this->input->post('isbn', true),
                'stok' => $this->input->post('stok', true),
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => $gambar
            ];

            $this->ModelBuku->simpanBuku($data);
            redirect('buku');
        }
    }


    public function kategori()
    {
        $data['judul'] = 'Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('buku/kategori', $data);
        $this->load->view('templates/footer');
    }

    public function ubahKategori()
    {
        $where =  $this->uri->segment(3);
        // var_dump($where);
        // die;

        $data['judul'] = 'Edit Kategori';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->kategoriWhere($where)->result_array();

        // var_dump($data['kategori']);
        // die;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('buku/ubah_kategori', $data);
        $this->load->view('templates/footer');
    }

    public function editKategori()
    {
        $data['judul'] = 'Edit Kategori';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $kategori = $this->input->post('kategori');
        $id =  $this->input->post('id');
        $this->db->set('kategori', $kategori);
        $this->db->where('id', $id);
        $this->db->update('kategori');
        redirect('buku/kategori');
    }

    public function tambahKategori()
    {
        $data['judul'] = 'tambah Kategori';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $data = [
            'kategori' => htmlspecialchars($this->input->post('kategori')),
        ];

        // var_dump($data);
        // die;

        $this->db->insert('kategori', $data);
        redirect('buku/kategori');
    }

    public function hapusKategori()
    {
        $id =  $this->uri->segment(3);
        $this->db->where('id', $id);
        $this->db->delete('kategori');
        redirect('buku/kategori');
    }


    public function hapusBuku()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelBuku->hapusKategori($where);
        redirect('buku');
    }

    public function ubahBuku()
    {
        $data['judul'] = 'Ubah Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->bukuWhere(['id' => $this->uri->segment(3)])->result_array();
        $kategori = $this->ModelBuku->joinKategoriBuku(['buku.id' => $this->uri->segment(3)])->result_array();
        foreach ($kategori as $k) {
            $data['id'] = $k['id_kategori'];
            $data['k'] = $k['kategori'];
        }
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        $this->form_validation->set_rules('judul_buku', 'Judul Buku', 'required|min_length[3]', [
            'required' => 'Judul Buku harus diisi',
            'min_length' => 'Judul buku terlalu pendek'
        ]);
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
            'required' => 'Nama pengarang harus diisi',
        ]);
        $this->form_validation->set_rules('pengarang', 'Nama Pengarang', 'required|min_length[3]', [
            'required' => 'Nama pengarang harus diisi',
            'min_length' => 'Nama pengarang terlalu pendek'
        ]);
        $this->form_validation->set_rules('penerbit', 'Nama Penerbit', 'required|min_length[3]', [
            'required' => 'Nama penerbit harus diisi',
            'min_length' => 'Nama penerbit terlalu pendek'
        ]);
        $this->form_validation->set_rules('tahun', 'Tahun Terbit', 'required|min_length[3]|max_length[4]|numeric', [
            'required' => 'Tahun terbit harus diisi',
            'min_length' => 'Tahun terbit terlalu pendek',
            'max_length' => 'Tahun terbit terlalu panjang',
            'numeric' => 'Hanya boleh diisi angka'
        ]);
        $this->form_validation->set_rules('isbn', 'Nomor ISBN', 'required|min_length[3]|numeric', [
            'required' => 'Nama ISBN harus diisi',
            'min_length' => 'Nama ISBN terlalu pendek',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);
        $this->form_validation->set_rules(
            'stok',
            'Stok',
            'required|numeric',
            [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]
        );

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        //memuat atau memanggil library upload
        $this->load->library('upload', $config);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/ubah_buku', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data();
                unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE));
                $gambar = $image['file_name'];
            } else {
                $gambar = $this->input->post('old_pict', TRUE);
            }

            $data = [
                'judul_buku' => $this->input->post('judul_buku', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'pengarang' => $this->input->post('pengarang', true),
                'penerbit' => $this->input->post('penerbit', true),
                'tahun_terbit' => $this->input->post('tahun', true),
                'isbn' => $this->input->post('isbn', true),
                'stok' => $this->input->post('stok', true),
                'image' => $gambar
            ];

            $this->ModelBuku->updateBuku($data, ['id' => $this->input->post('id')]);
            redirect('buku');
        }
    }
}

//modelbuku
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelBuku extends CI_Model
{
    //manajemen buku
    public function getBuku()
    {
        return $this->db->get('buku');
    }

    public function bukuWhere($where)
    {
        return $this->db->get_where('buku', $where);
    }

    public function simpanBuku($data = null)
    {
        $this->db->insert('buku', $data);
    }

    public function updateBuku($data = null, $where = null)
    {
        $this->db->update('buku', $data, $where);
    }

    public function hapusBuku($where = null)
    {
        $this->db->delete('buku', $where);
    }

    public function total($field, $where)
    {
        $this->db->select_sum($field);
        if (!empty($where) && count($where) > 0) {
            $this->db->where($where);
        }
        $this->db->from('buku');
        return $this->db->get()->row($field);
    }

    //manajemen kategori
    public function getKategori()
    {
        return $this->db->get('kategori');
    }

    public function kategoriWhere($where)
    {
        $query = $this->db->query("SELECT * FROM kategori where id=$where");
        return $query;
    }

    public function simpanKategori($data = null)
    {
        $this->db->insert('kategori', $data);
    }

    public function hapusKategori($where)
    {
        $this->db->delete('kategori', $where);
    }

    public function updateKategori($where = null, $data = null)
    {
        $this->db->update('kategori', $data, $where);
    }

    // join
    public function joinKategoriBuku($where)
    {
        $this->db->select('buku.id_kategori,kategori.kategori');
        $this->db->from('buku');
        $this->db->join('kategori', 'kategori.id = buku.id_kategori');
        $this->db->where($where);
        return $this->db->get();
    }
}


// buku index
<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-12">
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php } ?>
            <?= $this->session->flashdata('pesan'); ?>
            <a href="" class="btn btn-primary mb-3" datatoggle="modal" data-target="#bukuBaruModal"><i class="fas fa-filealt"></i> Buku Baru</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Pengarang</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Stok</th>
                        <th scope="col">DiPinjam</th>
                        <th scope="col">DiBooking</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Pilihan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $a = 1;
                    foreach ($buku as $b) { ?>
                        <tr>
                            <th scope="row"><?= $a++; ?></th>
                            <td><?= $b['judul_buku']; ?></td>
                            <td><?= $b['pengarang']; ?></td>
                            <td><?= $b['penerbit']; ?></td>
                            <td><?= $b['tahun_terbit']; ?></td>
                            <td><?= $b['isbn']; ?></td>
                            <td><?= $b['stok']; ?></td>
                            <td><?= $b['dipinjam']; ?></td>
                            <td><?= $b['dibooking'];
                                ?></td>
                            <td>
                                <picture>
                                    <source srcset="" type="image/svg+xml">
                                    <img src="<?= base_url('assets/img/upload/') . $b['image']; ?>" class="img-fluid img-thumbnail" alt="...">
                                </picture>
                            </td>

                            <td>
                                <a href="<?= base_url('buku/ubahBuku/') . $b['id']; ?>" class="badge badge-info"><i class="fas fa-edit"></i> Ubah</a>
                                <a href="<?= base_url('buku/hapusbuku/') . $b['id']; ?>" onclick="return confirm('Kamu yakin akan menghapus <?= $judul . '' . $b['judul_buku']; ?> ?');" class="badge badge-danger"><i class="fasfa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal Tambah buku baru -->
<div v class="modal fade" id="bukuBaruModal" tabindex="-1" role="dialog" aria-labelledby="bukuBaruModalLabel" ariahidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bukuBaruModalLabel">Tambah Buku</h5>
                <button type="button" class="close" datadismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('buku'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control formcontrol-user" id="judul_buku" name="judul_buku" placeholder="Masukkan Judul Buku">
                    </div>

                    <div class="form-group">
                        <select name="id_kategori" class="formcontrol form-control-user">
                            <option value="">Pilih Kategori</option>
                            <?php
                            foreach ($kategori as $k) { ?>
                                <option value="<?= $k['id']; ?>"><?= $k['kategori']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control formcontrol-user" id="pengarang" name="pengarang" placeholder="Masukkan nama pengarang">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control formcontrol-user" id="penerbit" name="penerbit" placeholder="Masukkan nama penerbit">
                    </div>

                    <div class="form-group">
                        <select name="tahun" class="form-control form-control-user">
                            <option value="">Pilih Tahun</option>
                            <?php
                            for ($i = date('Y'); $i > 1000; $i--) { ?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control formcontrol-user" id="isbn" name="isbn" placeholder="Masukkan ISBN">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control formcontrol-user" id="stok" name="stok" placeholder="Masukkan nominal stok">
                    </div>

                    <div class="form-group">
                        <input type="file" class="form-control formcontrol-user" id="image" name="image">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Tambah Mneu -->

//
