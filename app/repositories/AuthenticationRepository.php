<?php

interface AuthenticationRepository
{
	public function getUser();
	public function login($credentials,$remember);
	public function register($details);
	public function activate($code);
	public function getResetCode($email);
	public function checkResetCode($code);
	public function resetPassword($code,$password);
	public function logout();
}