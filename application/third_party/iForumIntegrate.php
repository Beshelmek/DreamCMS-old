<?php
interface iForumIntegrate
{
    public function getUser($email);
    public function registerUser($name, $email, $password);
    public function removeUser($id);
    public function updatePassword($id, $password);
    public function updateEmail($id, $password);
    public function findIPAddresses($id);
    public function authenticateMember($email, $password);
}