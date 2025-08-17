<?php

namespace App\Models;
use CodeIgniter\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nome', 'email', 'senha'];

    public function getInfoUsers($infoUser, $idenidentity) {
        
        $builder = $this->db->table($this->table . ' u');
        $builder->select('*');

        if($idenidentity == 'generate_xml') {
            $builder->where('u.id', $infoUser);
        } else {
            $builder->where('u.email', $infoUser);
        }

        $query = $builder->get()->getRow();
        return $query;

        // $query = $this->db->query("SELECT * FROM usuarios");
        // return $query->getRow();
    }

    public function insertByArray($data) {        
        $this->insert($data);
    }

public function redefinirSenhaPorEmail($email, $novaSenha) {
    $user = $this->where('email', $email)->first();

    if (!$user) {
        return "E-mail não encontrado!";
    }

    $hash = password_hash($novaSenha, PASSWORD_BCRYPT);

    $this->update($user['id'], [
        'senha' => $hash
    ]);

    $mensagem = "
        <h2>Redefinição de senha</h2>
        <p>A senha do seu software WS INtegration foi redefinida com Sucesso!</p>
    ";

    $resultadoEmail = $this->enviarEmail($email, $mensagem);

    if ($resultadoEmail !== true) {
        return $resultadoEmail;
    }

    return "Senha redefinida com sucesso!";
}

    private function enviarEmail($destinatario) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'integrationws@gmail.com';
            $mail->Password   = 'nnsm mfyi cqib kxrg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('wesleysantoscardoso2404@gmail.com', 'Suporte');
            $mail->addAddress($destinatario);

            $mail->isHTML(true);
            $mail->Subject = 'Senha redefinida';
            $mail->Body    = "
                <h2>Redefinição de senha</h2>
                <p>Sua senha foi redefinida com sucesso!</p>
            ";

            $mail->send();
            return true;

        } catch (\Exception $e) {
            return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    }

}