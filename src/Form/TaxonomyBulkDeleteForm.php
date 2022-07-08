<?php

namespace Drupal\taxonomy_bulk_delete\Form;

use Drupal\Core\FormBase;
use Drupal\Core\FormStateInterface;

class TaxonomyBulkDeleteForm extends FormBase {

    // Form Id
    public function getFormId() {
        return 'taxonomy_bulk_delete';
    }

    //Build Form
    public function buildForm(array $form, FormStateInterface $form_state) {

    }

    //Submit Form
    public function submitForm(array $form, FormStateInterface $form_state) {
        
    }


}