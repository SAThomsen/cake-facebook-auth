<?php
namespace FacebookAuth\Controller;

use FacebookAuth\Controller\AppController;

/**
 * SocialProfiles Controller
 *
 * @property \FacebookAuth\Model\Table\SocialProfilesTable $SocialProfiles
 */
class SocialProfilesController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $socialProfile = $this->SocialProfiles->newEntity();
        if ($this->request->is('post')) {
            $socialProfile = $this->SocialProfiles->patchEntity($socialProfile, $this->request->data);
            if ($this->SocialProfiles->save($socialProfile)) {
                $this->Flash->success(__('The social profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The social profile could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('socialProfile'));
        $this->set('_serialize', ['socialProfile']);
    }
}
