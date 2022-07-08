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
        $vocabularies = \Drupal::entityTypeManager()->getStorage('taxonomy_vocabulary')->loadMultiple();
        $vocab_names = [];
        foreach($vocabularies as $vocab) {
            $name = $vocab->get('name');
            $vid = $vocab->get('vid');
            $vocab_names[] = [$name => $vid];
        }

        $form['vocabs'] = [
            '#type' => 'select',
            '#title' => 'Select Type',
            '#options' => $vocab_names,
            ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'OK'
        ];

        return $form;
    }

    //Submit Form
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $selected_term = $form_state->getValue('vocabs');
        
        $tids = \Drupal::entityQuery('taxonomy_term')->condition('vid', $selected_term)->execute();
        $term_storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
        $entities = $term_storage->loadMultiple($tids);
        $term_storage->delete($entities);


        $messenger = \Drupal::messenger()->addMessage($selected_term);
    }


}