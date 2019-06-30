<?php

namespace Drupal\commerce_checkout_extra_field\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;
use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * @CommerceCheckoutPane(
 *  id = "commerce_checkout_pane",
 *  label = @Translation("Order extra fields"),
 *  display_label = @Translation("Order extra fields"),
 *  default_step = "order_information",
 *  wrapper_element = "fieldset",
 * )
 */
class CustomOrderFields extends CheckoutPaneBase implements  CheckoutPaneInterface {

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationSummary() {
    $summary = $this->t('Recolect extra fields');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function buildPaneSummary() {
    return [
      '#plain_text' => $this->order->get('field_recojo_en_tienda')->value ? 
        'Recoger en tienda' : 'Despacho a dirección proporcionada',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form['recojo_en_tienda'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Recoger en tienda'),
      '#default_value' => $this->order->get('field_recojo_en_tienda')->value,
      '#required' => FALSE,
      '#description' => $this->t('Marque esta opción si desea recoger su pedido en la tienda'),
    ];

    return $pane_form;
  }

  /**
   * {@inheritdoc}
   */
  public function validatePaneForm(array &$pane_form, FormStateInterface $form_state, array &$complete_form) {
/*    $values = $form_state->getValue($pane_form['#parents']);
    if ($this->configuration['double_entry'] && $values['email'] != $values['email_confirm']) {
      $form_state->setError($pane_form, $this->t('The specified emails do not match.'));
    } */
  }

  /**
   * {@inheritdoc}
   */
  public function submitPaneForm(array &$pane_form, FormStateInterface $form_state, array &$complete_form) {
    $values = $form_state->getValue($pane_form['#parents']);
    $this->order->set('field_recojo_en_tienda', $values['recojo_en_tienda']);
  }

}
