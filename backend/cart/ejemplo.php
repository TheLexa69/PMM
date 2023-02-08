<?php
require_once 'carrito.php';
$o1 = new carrito();
print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");

print var_dump($o1->getCarro("restaurante@b01.daw2d.iesteis.gal"));

$o1->add(1, 5, 2);
print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");

$o1->removeItem(5);
print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");

print var_dump($o1->getTotalPrice("restaurante@b01.daw2d.iesteis.gal"));

$o1->clearCarro("restaurante@b01.daw2d.iesteis.gal");
print $o1->printCarro("restaurante@b01.daw2d.iesteis.gal");
