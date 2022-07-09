<?php

namespace Drupal\taxonomy_bulk_delete\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TaxonomyBulkDeleteForm extends FormBase {

    // Form Id
    public function getFormId() {
        return 'taxonomy_bulk_delete';
    }

    //Build Form
    public function buildForm(array $form, FormStateInterface $form_state) {
        //Get all taxonomy terms
        $vocabularies = \Drupal::entityTypeManager()->getStorage('taxonomy_vocabulary')->loadMultiple();
        
        //Get the name and ID of each term
        $vocab_names = [];
        foreach($vocabularies as $vocab) {
            $name = $vocab->get('name');
            $vid = $vocab->get('vid');
            $vocab_names[] = [$name => $vid];
        }

        //List the available taxonomy terms
        $form['vocabs'] = [
            '#type' => 'select',
            '#title' => 'Select Type',
            '#options' => $vocab_names,
            ];

        //Submit
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'OK'
        ];

        return $form;
    }

    //Submit Form
    public function submitForm(array &$form, FormStateInterface $form_state) {
        //Get selected taxonomy term
        $selected_term = $form_state->getValue('vocabs');
        
        //Get IDs for each term
        $tids = \Drupal::entityQuery('taxonomy_term')->condition('vid', $selected_term)->execute();
        
        //Get taxonomy entity
        $term_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
        
        //Load terms from IDs
        $entities = $term_storage->loadMultiple($tids);
        
        //Delete terms
        $term_storage->delete($entities);

        //Confirmation message
        $messenger = \Drupal::messenger()->addMessage(count($tids)." deleted from ".$selected_term);
    }


}