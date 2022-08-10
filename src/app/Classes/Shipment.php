<?php

namespace PatrykSawicki\InPost\app\Classes;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use PatrykSawicki\InPost\app\Models\Cash;
use PatrykSawicki\InPost\app\Models\Parcels;
use PatrykSawicki\InPost\app\Models\Receiver;
use PatrykSawicki\InPost\app\Models\Sender;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class Shipment extends Api
{
    private int $organizationId;
    private Receiver $receiver;
    private Sender $sender;
    private Parcels $parcels;
    private Cash $insurance, $cod;
    private string $service, $comments, $reference, $external_customer_id, $mpk;
    private array $additional_services, $custom_attributes;
    private bool $is_return, $only_choice_of_offer;

    /**
     * Set organization id.
     *
     * @param int $organizationId
     */
    public function setOrganizationId(int $organizationId): void
    {
        $this->organizationId = $organizationId;
    }

    /**
     * Set receiver.
     *
     * @param Receiver $receiver
     */
    public function setReceiver(Receiver $receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * Set sender.
     *
     * @param Sender $sender
     */
    public function setSender(Sender $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * Set parcels.
     *
     * @param Parcels $parcels
     */
    public function setParcels(Parcels $parcels): void
    {
        $this->parcels = $parcels;
    }

    /**
     * Set insurance.
     *
     * @param Cash $insurance
     */
    public function setInsurance(Cash $insurance): void
    {
        $this->insurance = $insurance;
    }

    /**
     * Set cod.
     *
     * @param Cash $cod
     */
    public function setCod(Cash $cod): void
    {
        $this->cod = $cod;
    }

    /**
     * Set service.
     *
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * Set comments.
     *
     * @param string $comments
     */
    public function setComments(string $comments): void
    {
        $this->validateComments($comments);
        $this->comments = $comments;
    }

    /**
     * Set additional services.
     *
     * @param array $additional_services
     */
    public function setAdditionalServices(array $additional_services): void
    {
        $this->validateAdditionalServices($additional_services);
        $this->additional_services = $additional_services;
    }

    /**
     * Set custom attributes.
     *
     * @param array $custom_attributes
     */
    public function setCustomAttributes(array $custom_attributes): void
    {
        $this->custom_attributes = $custom_attributes;
    }

    /**
     * Set reference.
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->validateReference($reference);
        $this->reference = $reference;
    }

    /**
     * Set external customer id.
     *
     * @param string $external_customer_id
     */
    public function setExternalCustomerId(string $external_customer_id): void
    {
        $this->external_customer_id = $external_customer_id;
    }

    /**
     * Set mpk.
     *
     * @param string $mpk
     */
    public function setMpk(string $mpk): void
    {
        $this->mpk = $mpk;
    }

    /**
     * Set is return.
     *
     * @param bool $is_return
     */
    public function setIsReturn(bool $is_return): void
    {
        $this->is_return = $is_return;
    }

    /**
     * Set only choice of offer.
     *
     * @param bool $only_choice_of_offer
     */
    public function setOnlyChoiceOfOffer(bool $only_choice_of_offer): void
    {
        $this->only_choice_of_offer = $only_choice_of_offer;
    }

    public function __construct()
    {
        $this->is_return = false;
        $this->only_choice_of_offer = false;

        parent::__construct();
    }

    /**
     * Send a new shipment.
     *
     * @param bool $returnJson
     * @return string|array
     */
    public function send(bool $returnJson = false)
    {
        $this->validateShipment();

        $route = "/v1/organizations/{$this->organizationId}/shipments";

        $data = [
            'service'   => $this->service,
            'receiver'  => $this->receiver->toArray(),
            'sender'    => isset($this->sender) ? $this->sender->toArray() : null,
            'parcels'   => $this->parcels->toArray(),
            'insurance' => isset($this->insurance) ? $this->insurance->toArray() : null,
            'cod'       => isset($this->cod) ? $this->cod->toArray() : null,
            'additional_services' => $this->additional_services ?? [],
            'reference' => $this->reference ?? null,
            'comments'  => $this->comments ?? null,
            'external_customer_id' => $this->external_customer_id ?? null,
            'mpk' => $this->mpk ?? null,
            'custom_attributes' => $this->custom_attributes ?? [],
            'is_return' => $this->is_return,
            'only_choice_of_offer' => $this->only_choice_of_offer,
        ];

        $response = Http::withHeaders($this->requestHeaders())->post($this->url.$route, $data);

        return $returnJson ? $response->body() : json_decode($response->body(), true);
    }

    /**
     * Cancellation of a shipment.
     *
     * @param int $id
     * @param bool $returnJson
     * @return string|array
     */
    public function cancel(int $id, bool $returnJson = false)
    {
        $route = "/v1/shipments/$id";

        $response = Http::withHeaders($this->requestHeaders())->delete($this->url.$route);

        return $returnJson ? $response->body() : json_decode($response->body(), true);
    }

    /**
     * Get label for a shipment.
     *
     * @param int $id
     * @param string $format
     * @param string $type
     * @return Response|mixed
     * @throws BindingResolutionException
     */
    public function label(int $id, string $format = 'pdf', string $type = 'normal')
    {
        $route = "/v1/shipments/$id/label";

        $data = [
            'format' => $format,
            'type' => $type,
        ];

        $response = Http::withHeaders($this->requestHeaders())->get($this->url.$route, $data);

        return response()->make($response->getBody()->getContents(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="label-' . $id . '.pdf"'
        ]);
    }

    /**
     * Validate shipment.
     */
    private function validateShipment(): void
    {
        $this->validateOrganizationId();
        $this->validateReceiver();
        $this->validateParcels();
        $this->validateService();
    }

    /**
     * Validate receiver.
     */
    private function validateReceiver(): void
    {
        if(empty($this->receiver))
            throw new InvalidArgumentException('Receiver is not set.');
    }

    /**
     * Validate parcels.
     */
    private function validateParcels(): void
    {
        if(empty($this->parcels))
            throw new InvalidArgumentException('Parcels is not set.');
    }

    /**
     * Validate organization id.
     */
    private function validateOrganizationId(): void
    {
        if(!$this->organizationId)
            throw new InvalidArgumentException('Organization id is not set.');
    }

    /**
     * Validate service.
     */
    private function validateService(): void
    {
        if(empty($this->service))
            throw new InvalidArgumentException('Service is not set.');
    }

    /**
     * Validate additional services.
     */
    private function validateAdditionalServices(array $additional_services): void
    {
        if(!empty($additional_services))
        {
            foreach($additional_services as $service)
            {
                if(!is_string($service))
                    throw new InvalidArgumentException("Invalid additional service: $service");
            }
        }
    }

    /**
     * Validate reference.
     */
    private function validateReference(?string $reference): void
    {
        if(empty($reference))
            return;

        if(strlen($reference) < 3)
            throw new InvalidArgumentException("Invalid reference: $reference. Reference minimum length is 3");

        if(strlen($reference) > 100)
            throw new InvalidArgumentException("Invalid reference: $reference. Reference maximum length is 100");
    }

    /**
     * Validate comments.
     */
    private function validateComments(?string $comments): void
    {
        if(empty($comments))
            return;

        if(strlen($comments) > 100)
            throw new InvalidArgumentException("Invalid comments: $comments. Comments maximum length is 100");
    }
}