<?php 
  $app->get("/contactssubtypes",function(){
   $contact =  ContactsSubTypes::listAll();

   if ((int)get('idcontacttype') > 0) {

   	$contact = $contact->filter('idcontacttype', (int)get('idcontacttype'));

   }

   echo success(array(
     "data"=> $contact->getFields()
   	));

  });

 ?>