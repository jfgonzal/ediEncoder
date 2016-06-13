<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EDI850 extends Model
{
//    Time and date variables
    protected $currentDate, $currentTime;

//    Segment related variables
    protected $ISA, $GS, $ST, $BEG, $CUR, $REF, $SAC, $ITD, $DTM, $TD5, $extendedDataLoop,
        $identifierLoop, $productLoop, $CTT, $EDIDoc, $itemCounter, $SE, $GE, $IEA;

//    I did not have enough time to thoroughly read through the entire document to understand
//      proper error handling when limit is reached, thus these variables went unused.
    const SACMaxLoopLength = 25, extendedDataMaxLoopLength = 2, identificationMaxLoopLength = 4,
        PO1MaxLoopLength = 100000, PIDMaxLoopLength = 1000;

//    The constructor initiates the time and date variables as well as the item counter
    public function __construct()
    {
        $this->currentDate = Carbon::now()->format('Ymd');
        $this->currentTime = Carbon::now()->format('hs');
        $this->itemCounter = 0;
    }

//    this method parses through the array and builds each segment separately
    public function createEDI850($request)
    {
        foreach ($request as $ediSegment) {
            switch (key($ediSegment)) {
                case 'ISA':
                    $this->setISA($ediSegment['ISA']);
                    break;
                case 'GS':
                    $this->setGS($ediSegment['GS']);
                    break;
                case 'ST':
                    $this->setST($ediSegment['ST']);
                    break;
                case 'BEG':
                    $this->setBEG($ediSegment['BEG']);
                    break;
                case 'CUR':
                    $this->setCUR($ediSegment['CUR']);
                    break;
                case 'REF':
                    $this->setREF($ediSegment['REF']);
                    break;
                case 'SAC':
                    $this->setSAC($ediSegment['SAC']);
                    break;
                case 'ITD':
                    $this->setITD($ediSegment['ITD']);
                    break;
                case 'TDM':
                    $this->setTDM($ediSegment['TDM']);
                    break;
                case 'TD5':
                    $this->setTD5($ediSegment['TD5']);
                    break;
                case 'identifierLoop':
                    $this->setIdentifierLoop($ediSegment['identifierLoop']);
                    break;
                case 'productLoop':
                    $this->setProductLoop($ediSegment['productLoop']);
                    break;
                case 'SE':
                    $this->setSE($ediSegment['SE']);
                    break;
                default:
                    break;
            }

        }
// The assembling of the document is done right before it is
//  returned to the controller for it to present to the view
        return $this->constructEDI850();
    }

//    The following methods deal with constructing the segments
    public function setISA($isaData)
    {
        $this->ISA = 'ISA*00**00*ZZ*' . $isaData['senderId'] . '*12*' . $isaData['receiverId'] . '*' .
            $this->currentDate . '*' . $this->currentTime . '*U*05010*000000001*0*P*P~';
    }

    public function setGS($gsData)
    {
        $this->GS = 'GS*PO*' . $gsData['senderCode'] . '*' . $gsData['receiverCode'] . '*' . $this->currentDate .
            '*' . $this->currentTime . '*1*X*005010~';
    }

    public function setST($stData)
    {
        $this->ST = 'ST*' . $stData['code'] . '*' . $stData['code'] . '';
    }

    public function setBEG($begData)
    {
        $this->BEG = 'BEG*' . $begData['purposeCode'] . '*' . $begData['orderTypeCode'] . '*' .
            $begData['purchaseOrderNumber'] . '**' . $this->currentDate . '~';
    }

    public function setCUR($curData)
    {
        $this->CUR = 'CUR*' . $curData['identifierCode'] . '*' . $curData['currencyCode'] . '~';
    }

    public function setREF($refData)
    {
        foreach ($refData as $ref) {
            $this->REF .= 'REF*' . $ref['referenceIdentifier'] . '*' . $ref['referenceIdentification'] . '~';
        }

    }

    public function setSAC($sacData)
    {
        foreach ($sacData as $sac) {
            $this->SAC .= 'SAC*' . $sac['indicator'] . '*' . $sac['promoCode'] . '***0**********~';
        }
    }

    public function setITD($itdData)
    {
        $this->ITD = 'ITD*' . $itdData['typeCode'] . '*' . $itdData['dateCode'] . '**********~';
    }

    public function setTDM($dtmData)
    {
        $this->DTM = 'DTM*' . $dtmData['dateQualifier'] . '*' . $this->currentDate . '~';
    }

    public function setTD5($td5Data)
    {
        $this->TD5 = 'TD5****' . $td5Data['transportMethod'] . '*' . $td5Data['routing'] . '*******ST*DS~';
    }
// Looping through identifiers
    public function setIdentifierLoop($identifierData)
    {
        foreach ($identifierData as $identifierGroup) {
            $PER = $N4 = $N3 = $N2 = $N1 = '';
            foreach ($identifierGroup as $segmentKey => $identifierSegment) {
                switch ($segmentKey) {
                    case 'N1':
                        $N1 = 'N1*' . $identifierSegment['identifierCode'] . '*' . $identifierSegment['name'] . '~';
                        break;
                    case 'N2':
                        $N2 = 'N2*' . $identifierSegment['name'] . '~';
                        break;
                    case 'N3':
                        $N3 = 'N3*' . $identifierSegment['addressInfo1'] . '*' . $identifierSegment['AddressInfo2'] . '~';
                        break;
                    case 'N4':
                        $N4 = 'N4*' . $identifierSegment['cityName'] . '*' . $identifierSegment['state'] . '*' .
                            $identifierSegment['postalCode'] . '*' . $identifierSegment['countryCode'] . '~';
                        break;
                    case 'PER':
                        $PER = 'PER*' . $identifierSegment['functionCode'] . '*' . $identifierSegment['name']
                            . '*' . $identifierSegment['comQualifier'] . '*' . $identifierSegment['comQualifier']
                            . '*' . $identifierSegment['numberQualifier'] . '*' . $identifierSegment['comNumber2'] . '~';
                        break;
                }

            }
            $this->identifierLoop .= $N1 . $N2 . $N3 . $N4 . $PER;
        }
    }
//Looping through product loop
    public function setProductLoop($productData)
    {
        foreach($productData as $productSegments){
            $PO1 = $PID = '';
            foreach($productSegments['PO1'] as $baseLine){
                $PO1 .= 'PO1*'. $baseLine['assignedIden'] .'*'. $baseLine['quantity'] .
                    '*'. $baseLine['measurementCode'] .'*'. $baseLine['unitPrice'] .'**'.
                    $baseLine['serviceIdQualifier1'] .'*'. $baseLine['serviceId1'] .
                    '*'. $baseLine['serviceIdQualifier2'] .'*'. $baseLine['serviceId2'] .
                    '*'. $baseLine['serviceIdQualifier3'] .'* '. $baseLine['serviceId3'] .'~';
            }
            foreach($productSegments['PID'] as $description){
                $PID .= 'PID*'. $description['itemDescriptionType'] .'*'. $description['characteristicCode'] .
                    '***'. $description['description'] .'~';
            }
            $this->productLoop .= $PO1 . $PID;
            $this->itemCounter++;
        }
    }

    public function setSE($seData)
    {
        $this->CTT = 'CTT*'. $this->itemCounter .'~';
        $this->SE = 'SE*'. $seData['includedSegment'] .'*'. $seData['controlNumber'] .'~';
        $this->GE = 'GE*1*1~';
        $this->IEA = 'IEA*1*000000001~';
    }

    public function constructEDI850(){

        $ediDocument = $this->ISA . $this->GS . $this->ST . $this->BEG
                          . $this->CUR . $this->REF . $this->SAC . $this->ITD . $this->DTM
                          . $this->TD5 . $this->identifierLoop . $this->productLoop . $this->CTT
                          . $this->SE . $this->GE . $this->IEA;

        return $ediDocument;
    }
}
