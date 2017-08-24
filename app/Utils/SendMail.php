<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 26/07/2017
 * Time: 16:15
 */

namespace App\Utils;

use Illuminate\Support\Facades\Mail;
use App\Company;

class SendMail
{
    protected $mail_from = '';
    protected $mail_admin = '';
    const TPL_USER_REGISTER = 'email.user_register-email';
    const TPL_ADMIN_REGISTER = 'email.admin_register-email';
    const TPL_USER_REGISTER_CHANGE = 'email.user_register_change-email';
    const TPL_ADMIN_REGISTER_CHANGE = 'email.admin_register_change-email';
    const TPL_USER_REGISTER_ACTIVE = 'email.user_register_active';


    function __construct()
    {

        $this->mail_from = env('MAIL_FROM');
        $this->mail_admin = env('MAIL_ADMIN');
    }

    public function SendRegister($to, Company $company)
    {
        $data = array(
            'company' => $company,
            'title' => 'Seja Bem vindo'
        );

        Mail::send(self::TPL_USER_REGISTER, $data, function ($message) use ($to, $company) {
            $message->to($to, $company->companyname)->subject('Bem vindo - Aguardando aprovação');

            $message->from($this->mail_from, 'Busca Dados');
        });

        $data = array(
            'company' => $company,
            'title' => 'Novo Cadastro',
            'email' => $to
        );

        Mail::send(self::TPL_ADMIN_REGISTER, $data, function ($message) use ($company) {
            $message->to($this->mail_admin, $company->companyname)->subject('Novo cadastro aguardando aprovação');

            $message->from($this->mail_from, 'Busca Dados');
        });
    }

    public function SendEnabled($to, Company $company)
    {
        $data = array(
            'company' => $company,
            'title' => 'Cadastro',
            'activated' => true
        );

        Mail::send(self::TPL_USER_REGISTER_ACTIVE, $data, function ($message) use ($to, $company) {
            $message->to($to, $company->companyname)->subject('Cadastro ativado com sucesso');

            $message->from($this->mail_from, 'Busca Dados');
        });
    }

    public function SendDisabled($to, Company $company)
    {
        $data = array(
            'company' => $company,
            'title' => 'Cadastro',
            'activated' => false
        );

        Mail::send(self::TPL_USER_REGISTER_ACTIVE, $data, function ($message) use ($to, $company) {
            $message->to($to, $company->companyname)->subject('Cadastro não ativado');

            $message->from($this->mail_from, 'Busca Dados');
        });
    }

    public function SendChanged($to, Company $company)
    {
        $data = array(
            'company' => $company,
            'title' => 'Cadastro alterado'
        );

        Mail::send(self::TPL_USER_REGISTER_CHANGE, $data, function ($message) use ($to, $company) {
            $message->to($to, $company->companyname)->subject('Alteração aguardando aprovação');

            $message->from($this->mail_from, 'Busca Dados');
        });

        $data = array(
            'company' => $company,
            'title' => 'Cadastro alterado',
            'email' => $to
        );

        Mail::send(self::TPL_ADMIN_REGISTER_CHANGE, $data, function ($message) use ($company) {
            $message->to($this->mail_admin, $company->companyname)->subject('Cadastro alterado aguardando aprovação');

            $message->from($this->mail_from, 'Busca Dados');
        });
    }


}