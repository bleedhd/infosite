<?php
echo l::get('contactForm.mailAdminIntro') . "\n\n";
echo l::get('contactForm.salutation') . ': ' . $data['salutation'] . "\n";
echo l::get('contactForm.name') . ': ' . $data['name'] . "\n";
echo l::get('contactForm.surname') . ': ' . $data['surname'] . "\n";
echo l::get('contactForm.address') . ': ' . $data['address'] . "\n";
echo l::get('contactForm.zip') . ': ' . $data['zip'] . "\n";
echo l::get('contactForm.city') . ': ' . $data['city'] . "\n";
echo l::get('contactForm.email') . ': ' . $data['email'] . "\n";
echo l::get('contactForm.phone') . ': ' . $data['phone'] . "\n";
echo l::get('contactForm.message') . ': ' . $data['message'] . "\n" . "\n";
echo l::get('contactForm.source') . ': ' . $data['source'] . "\n" . "\n";
