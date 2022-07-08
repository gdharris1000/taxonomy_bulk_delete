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
            $vocab_names[] = [$name => $name];
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
        $selected_term = $form_state['vocabs'];
        $messenger = \Drupal::messenger()->addMessage($selected_term, self::TYPE_STATUS);
    }


}