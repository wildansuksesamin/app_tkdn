
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Member_model", "member");
    }

    public function index()
    {
        $menu = 'member';
        if ($this->validasi_controller($menu) && $this->validasi_login()) {

            $konten = array();
            $this->load->view('member', $this->data_halaman($konten));
        } else
            $this->redirect(base_url() . 'gateway/keluar');
    }

    public function load_data()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            if ($this->tokenStatus($token, 'LOAD_DATA')) {
                $filter = (isset($data_receive->filter) ? $data_receive->filter : null);


                $page = $data_receive->page;
                $jml_data = $data_receive->jml_data;

                $page = (empty($page) ? 1 : $page);
                $jml_data = (empty($jml_data) ? $this->qty_data : $jml_data);
                $start = ($page - 1) * $jml_data;
                $limit = $jml_data . ',' . $start;

                $where = "member.active = 1  and (member.id_member like '%" . $filter . "%' or member.nama_member like '%" . $filter . "%' or member.tgl_lahir like '%" . $filter . "%' or member.tgl_daftar like '%" . $filter . "%' or member.waktu_login like '%" . $filter . "%' or member.user_create like '%" . $filter . "%' or member.time_create like '%" . $filter . "%' or member.time_update like '%" . $filter . "%' or member.user_update like '%" . $filter . "%' )";
                $send_data = array('where' => $where, 'limit' => $limit);
                $load_data = $this->member->load_data($send_data);
                $result = $load_data->result();

                #find last page...
                $select = "count(-1) jml";
                $send_data = array('where' => $where, 'select' => $select);
                $load_data = $this->member->load_data($send_data);
                $total_data = $load_data->row()->jml;

                $last_page = ceil($total_data / $jml_data);
                $result = array('result' => $result, 'last_page' => $last_page);

                echo json_encode($result);
            }
        }
    }

    public function simpan()
    {
        if ($this->validasi_login()) {
            $token = $this->input->post('token');
            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $id_member = htmlentities($this->input->post('id_member') ?? '');
                $nama_member = htmlentities($this->input->post('nama_member') ?? '');
                $tgl_lahir = htmlentities($this->input->post('tgl_lahir') ?? '');
                $tgl_daftar = htmlentities($this->input->post('tgl_daftar') ?? '');
                $waktu_login = htmlentities($this->input->post('waktu_login') ?? '');
                $user_create = $this->session->userdata('id_admin');
                $time_create = date('Y-m-d H:i:s');
                $time_update = date('Y-m-d H:i:s');
                $user_update = $this->session->userdata('id_admin');

                $action = htmlentities($this->input->post('action') ?? '');

                #jika action memiliki value 'save' maka data akan disimpan.
                #jika action tidak memiliki value, maka akan dianggap sebagai upadate.
                if ($action == 'save') {
                    $data = array(
                        'nama_member' => $nama_member,
                        'tgl_lahir' => $tgl_lahir,
                        'tgl_daftar' => $tgl_daftar,
                        'waktu_login' => $waktu_login,
                        'user_create' => $user_create,
                        'time_create' => $time_create,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $exe = $this->member->save($data);
                    $return['sts'] = $exe;
                } else {
                    $data = array(
                        'nama_member' => $nama_member,
                        'tgl_lahir' => $tgl_lahir,
                        'tgl_daftar' => $tgl_daftar,
                        'waktu_login' => $waktu_login,
                        'time_update' => $time_update,
                        'user_update' => $user_update
                    );
                    $where = array('id_member' => $id_member);
                    $exe = $this->member->update($data, $where);
                    $return['sts'] = $exe;
                }
            }

            echo json_encode($return);
        }
    }
    public function hapus()
    {
        if ($this->validasi_login()) {
            $data_receive = json_decode(urldecode($this->input->post('data_send')));
            $token = $data_receive->token;
            $id_member = $data_receive->id_member;

            $return = array();
            if ($this->tokenStatus($token, 'SEND_DATA')) {
                $where = array('id_member' => $id_member);
                $exe = $this->member->soft_delete($where);
                $return['sts'] = $exe;
            }

            echo json_encode($return);
        }
    }
}
