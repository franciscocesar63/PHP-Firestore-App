<?php


require_once 'vendor/autoload.php';


use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Firestore\FirestoreClient;

class Firestore
{
    protected $db;
    protected $name;
    public function __construct(string $collection)
    {
        $this->db = new FirestoreClient([
            'projectId' => "app-igreja-5679a",
            'keyFile' => json_decode(file_get_contents('./model/app-igreja-5679a-firebase-adminsdk-l3thp-fd7405e1ef.json'), true)
        ]);

        $this->name = $collection;
    }


    /**
     * Get document and all data with checking for exists
     * @param string $name
     * @return array|null|string
     */
    public function getDocument(string $name)
    {
        try {
            if (empty($name)) throw new Exception('Document name missing');
            if ($this->db->collection($this->name)->document($name)->snapshot()->exists()) {
                return $this->db->collection($this->name)->document($name)->snapshot()->data();
            } else {
                throw new Exception('Document are not exists');
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function getDocuments()
    {
        $documents = $this->db->collection($this->name)
        ->orderBy('titulo')
        ->documents();
        foreach ($documents as $document) {
            if ($document->exists()) {
                // printf('Document data for document %s:' . PHP_EOL, $document->id());
                echo $document->data()['titulo'];

                echo '<br><br>';
                printf(PHP_EOL);
            } else {
                printf('Document %s does not exist!' . PHP_EOL);
            }
        }
    }
}
