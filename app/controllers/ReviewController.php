<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Http\Response;


class ReviewController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for Review
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Review', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $review = Review::find($parameters);
        if (count($review) == 0) {
            $this->flash->notice("The search did not find any Review");

            $this->dispatcher->forward([
                "controller" => "Review",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $review,
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
     * Edits a Review
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $review = Review::findFirstByid($id);
            if (!$review) {
                $this->flash->error("Review was not found");

                $this->dispatcher->forward([
                    'controller' => "Review",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $review->getId();

            $this->tag->setDefault("id", $review->getId());
            $this->tag->setDefault("content", $review->getContent());
            $this->tag->setDefault("userId", $review->getUserid());
            $this->tag->setDefault("movieId", $review->getMovieid());
            
        }
    }

    /**
     * Creates a new Review
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Review",
                'action' => 'index'
            ]);

            return "review created succesfully!";
        }
        
        $review = new Review();
        $review->setcontent($this->request->getPost("content"));
        $review->setuserId($this->session->get("userId"));
        $review->setmovieId($this->session->get("movieId"));
        
        $movieId = $this->session->get("movieId");
        if (!$review->save()) {
            foreach ($review->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "review",
                'action' => 'new'
            ]);

            return;
        }
        $response = new Response();
        //$response->redirect("movie/edit/'$movieId'");
        $this->flash->success("Review was created successfully");

        $this->dispatcher->forward([
            'controller' => "Review",
            'action' => 'index'
        ]);
        return (["index"]);
    }

    /**
     * Saves a Review edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "Review",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $review = Review::findFirstByid($id);

        if (!$review) {
            $this->flash->error("Review does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "Review",
                'action' => 'index'
            ]);

            return;
        }

        $review->setcontent($this->request->getPost("content"));
        $review->setuserId($this->request->getPost("userId"));
        $review->setmovieId($this->request->getPost("movieId"));
        

        if (!$review->save()) {

            foreach ($review->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Review",
                'action' => 'edit',
                'params' => [$review->getId()]
            ]);

            return;
        }

        $this->flash->success("Review was updated successfully");
        
        $this->dispatcher->forward([
            'controller' => "Review",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a Review
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $review = Review::findFirstByid($id);
        if (!$review) {
            $this->flash->error("Review was not found");

            $this->dispatcher->forward([
                'controller' => "Review",
                'action' => 'index'
            ]);

            return;
        }

        if (!$review->delete()) {

            foreach ($review->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "Review",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Review was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "Review",
            'action' => "index"
        ]);
    }

}
