<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MovieController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for movie
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Movie', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $movie = Movie::find($parameters);
        if (count($movie) == 0) {
            $this->flash->notice("The search did not find any movie");

            $this->dispatcher->forward([
                "controller" => "movie",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $movie,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a movie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $movie = Movie::findFirstByid($id);
            $reviews = Review::find("movieId = '$id'");
            if (!$movie) {
                $this->flash->error("movie was not found");

                $this->dispatcher->forward([
                    'controller' => "movie",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $movie->getId();
            $this->session->set("movieId",$movie->getId());
            $this->tag->setDefault("id", $movie->getId());
            $this->tag->setDefault("name", $movie->getName());
            $this->tag->setDefault("description", $movie->getDescription());
            $this->tag->setDefault("rating", $movie->getRating());
            $this->tag->setDefault("image", $movie->getImage());
            
            foreach ($reviews as $review) {
                
                $this->tag->setDefault("review", $review->content);                
             }
             
            
        }
    }

    /**
     * Creates a new movie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        $movie = new Movie();
        $movie->setname($this->request->getPost("name"));
        $movie->setdescription($this->request->getPost("description"));
        $movie->setrating($this->request->getPost("rating"));
        $movie->setimage(base64_encode(file_get_contents($this->request->getUploadedFiles()[0]->getTempName())));
        

        if (!$movie->save()) {
            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("movie was created successfully");

        $this->dispatcher->forward([
            'controller' => "movie",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a movie edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $movie = Movie::findFirstByid($id);

        if (!$movie) {
            $this->flash->error("movie does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        $movie->setname($this->request->getPost("name"));
        $movie->setdescription($this->request->getPost("description"));
        $movie->setrating($this->request->getPost("rating"));
        $movie->setimage($this->request->getPost("image"));
        
        

        if (!$movie->save()) {

            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'edit',
                'params' => [$movie->getId()]
            ]);

            return;
        }

        $this->flash->success("movie was updated successfully");

        $this->dispatcher->forward([
            'controller' => "movie",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a movie
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $movie = Movie::findFirstByid($id);
        if (!$movie) {
            $this->flash->error("movie was not found");

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        if (!$movie->delete()) {

            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'search'
            ]);

            return;
        }


        $this->dispatcher->forward([
            'controller' => "movie",
            'action' => "index"
        ]);
    }

}
