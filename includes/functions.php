<?php
function e(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string { if(empty($_SESSION['csrf_token'])) $_SESSION['csrf_token']=bin2hex(random_bytes(32)); return $_SESSION['csrf_token']; }
function require_admin(): void { if(empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; } }
function track_visit(PDO $pdo): void {
  $token=$_COOKIE['visitor_token']??bin2hex(random_bytes(16));
  if(!isset($_COOKIE['visitor_token'])) setcookie('visitor_token',$token,['expires'=>time()+31536000,'path'=>'/','httponly'=>true,'samesite'=>'Lax']);
  $stmt=$pdo->prepare('INSERT INTO visits(visitor_token,visit_date,page_views) VALUES(?,CURDATE(),1) ON DUPLICATE KEY UPDATE page_views=page_views+1,last_visit=NOW()'); $stmt->execute([$token]);
}