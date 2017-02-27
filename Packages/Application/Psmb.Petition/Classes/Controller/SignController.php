<?php
namespace Psmb\Petition\Controller;

/*
 * This file is part of the Psmb.Petition package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\ContentRepository\Domain\Model\NodeType;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Validation\Validator\EmailAddressValidator;

class SignController extends ActionController
{
    /**
     * @Flow\Inject
     * @var \Neos\ContentRepository\Domain\Service\NodeTypeManager
     */
    protected $nodeTypeManager;
    /**
     * @var \Neos\ContentRepository\Domain\Service\Context
     */
    protected $context;
    /**
     * @Flow\Inject
     * @var \Neos\ContentRepository\Domain\Service\ContextFactoryInterface
     */
    protected $contextFactory;

    public function initializeObject() {
        $this->context = $this->contextFactory->create(array('workspaceName' => 'live'));
    }

    /**
     * @return void
     */
    public function indexAction()
    {
    }

    /**
     * Sign a petition
     *
     * @param string $name
     * @param string $email
     * @param string $place
     * @param string $comment
     * @param string $about
     * @return void
     */
    public function signAction($name = null, $email = null, $place = null, $comment = null, $about = null)
    {
        if (!$name) {
            $this->addFlashMessage("Укажите ваше имя");
            $this->redirect('index');
        } else {
            $emailValidator = new EmailAddressValidator();
            $validationResult = $emailValidator->validate($email);
            if ($validationResult->hasErrors()) {
                $this->addFlashMessage("Вы ввели неверный адрес, попробуйте снова");
                $this->redirect('index');
            } else {
                $rootNode = $this->context->getNode('/sites/site/petitions');
                $nodeTemplate = new \Neos\ContentRepository\Domain\Model\NodeTemplate();
                $nodeTemplate->setNodeType($this->nodeTypeManager->getNodeType('Psmb.Petition:Signature'));
                $nodeTemplate->setProperty('name', strip_tags($name));
                $nodeTemplate->setProperty('email', strip_tags($email));
                $nodeTemplate->setProperty('place', strip_tags($place));
                $nodeTemplate->setProperty('comment', strip_tags($comment));
                $nodeTemplate->setProperty('about', strip_tags($about));
                $node = $rootNode->createNodeFromTemplate($nodeTemplate);
                $node->setHidden(true);
                $this->addFlashMessage("Cпасибо!");
                $this->redirect('feedback');
            }
        }
    }

    /**
     * Just render flash messages
     */
    public function feedbackAction()
    {
    }

}
