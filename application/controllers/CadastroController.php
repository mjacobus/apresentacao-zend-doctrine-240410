<?php

class CadastroController extends Zend_Controller_Action
{

    /**
     * Realiza tarefas antes de executar a acao e renderizar a view
     */
    public function preDispatch()
    {
        $this->view->headTitle('Cadastro');
        $this->view->headScript()->appendFile($this->view->baseUrl('/js/jquery.js'));
        $this->view->headScript()->appendFile($this->view->baseUrl('/js/jquery.selectboxes.min.js'));
        $this->view->headScript()->appendFile($this->view->baseUrl('/js/site.js'));
    }

    /**
     * Lista todos os usuarios caso não tenha sido feita uma pesquisa.
     * Caso uma pesquisa tenha sido feita, lista apenas os usuarios que
     * se encaixam no filtro de pesquisa
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            //disponibiliza o $_POST['search'] para na view
            $this->view->search = $search = $request->getPost('search');
            $search = '%' . $search . '%';

            //instancia uma DQl
            $dql = Doctrine_Query::create();
            $dql->from('User u')
                    ->leftJoin('u.City c')
                    ->leftJoin('c.State e')
                    ->leftJoin('u.Software s')
                    ->addWhere('u.name like ?',  $search)
                    ->orWhere('u.email like ?', $search)
                    ->orWhere('c.name like ?',  $search)
                    ->orWhere('e.name like ? OR e.short = ?',
                            array($search,$search))
                    ->orWhere('s.name like ? ', $search);

            //verifica valores postados e pesquisa de acordo
            $users = $dql->execute();

            
        } else {
            $users = Doctrine_Core::getTable('User')->findAll();
        }
        
        //disponibiliza os usuarios na view
        $this->view->users = $users;
    }

    /**
     * Edita um usuario. Se for post, tenta salvar.
     * Caso contrario, apenas busca o usuario e "joga-o" para a view
     */
    public function editarAction()
    {
        $request = $this->getRequest();
        //busca o usuario pelo id
        $user = Doctrine_Core::getTable('User')->find($request->getParam('id'));

        if (!$user) {
            $this->view->flash('Usuário não existe');
            //redireciona para o /cadastro
            $this->_redirect($request->getControllerName());
        }

        $form = $this->setForm();
        
        if ($request->isPost())
            $this->save($user);

        $form->populate($user->toArray());
        
    }

    /**
     * Instancia um formulario
     * @return Zend_Form
     */
    public function setForm()
    {
        $form = $this->view->form = new Zend_Form();

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Nome')
                ->setRequired(true);





        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Salvar');
        $form->addElements(array($name, $submit));

        return $form;
    }

    /**
     * Caso os valores do post sejam validos, tenta savar o usuário.
     * Caso contrario, mostra os erros de validao e reapresenta
     * o formulari repreenhido.
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $form = $this->view->form;
        $data = $this->getRequest()->getPost();

        if ($form->isValid($data)) {
            try {
                $user->merge($data);
                $user->save();
                $this->view->flash('Usuário salvo com sucesso (mas que tal)!');
                $this->_redirect($this->_request->getControllerName());
            } catch (Exception $e) {
                $form->populate($data);
                $this->view->errors($e->getMessage());
            }
        } else {
            $form->populate($data);
        }
        //vai para a view
        $this->render();
    }
}

