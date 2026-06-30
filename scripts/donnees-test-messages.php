<?php


require __DIR__ . '/../vendor/autoload.php';

use Models\MessageModel;

$messageModel = new MessageModel();


$messages = [
    [
        'id_expediteur' => 2,
        'id_destinataire' => 6,
        'contenu' => 'Bonjour, je serai bien à l\'heure pour le trajet de demain.',
        'lu' => false,
        'date_envoi' => new \MongoDB\BSON\UTCDateTime(),
    ],
    [
        'id_expediteur' => 6,
        'id_destinataire' => 2,
        'contenu' => 'Parfait, rendez-vous à 8h devant la gare.',
        'lu' => false,
        'date_envoi' => new \MongoDB\BSON\UTCDateTime(),
    ],
    [
        'id_expediteur' => 3,
        'id_destinataire' => 6,
        'contenu' => 'Bonjour, avez-vous de la place pour un bagage volumineux ?',
        'lu' => false,
        'date_envoi' => new \MongoDB\BSON\UTCDateTime(),
    ],
    [
        'id_expediteur' => 6,
        'id_destinataire' => 3,
        'contenu' => 'Oui, pas de problème, le coffre est grand.',
        'lu' => true,
        'date_envoi' => new \MongoDB\BSON\UTCDateTime(),
    ],
];

$result = $messageModel->insertMany($messages);

echo "Messages insérés : " . count($result) . "\n";
foreach ($result as $id) {
    echo "- $id\n";
}