<?php
/*************************************** ORIGINAL CODE VERSION ***************************************/
	public function post_confirm() {
		$id = Input::get('service_id');
		$servicio = Service::find($id);
		//dd($servicio);
		if ($servicio !== NULL) {
			if ($servicio->status_id == '6') {
				return Response::json(array('error' => '2'));
			}
			if ($servicio->driver_id == NULL && $servicio->status_id == '1') {
				$servicio = Service::update($id, array(
							'driver_id' => Input::get('driver_id'),
							'status_id' => '2',
							//Up Carro
							//'pwd' => md5(Input::get('pwd'))
				));
				Driver::update(Input::get('driver_id'), array(
					"available" => '0'
				));
				$driverTmp = Driver::find(Input::get('driver_id'));
				Service::update($id, array(
					'car_id' => $driverTmp->car_id
					//Up Carro
					//'pwd' => md5(Input::get('pwd'))
				));
				//Notificar a usuario!!
				$pushMessage = 'Tu servicio ha sido confirmado!';
				/* $servicio = Service::find($id);
				$push = Push::make();
				if ($servicio->user->type == '1') { //iPhone
				$pushAns = $push->ios($servicio->user->uuid, $pushMessage);
				} else {
				$pushAns = $push->android($servicio->user->uuid, $pushMessage);
				}*/
				$servicio = Service::find($id);
				$push = Push::make();
				if ($servicio->user->uuid == '') {
					return Response::json(array('error' => '0'));
				}
				if ($servicio->user->type == '1') { //iPhone
					$result = $push->ios($servicio->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', array('serviceId' => $servicio->id));
				} else {
					$result = $push->android2($servicio->user->uuid, $pushMessage, 1, 'default', 'Open', array('serviceId' => $servicio->id));
				}
				return Response::json(array('error' => '0'));
			} else {
				return Response::json(array('error' => '1'));
			}
		} else {
			return Response::json(array('error' => '3'));
		}
	}

/************************************** REFACTORING CODE VERSION **************************************/
	public function post_confirm() {
		$inputServiceId = Input::get('service_id');
		$inputDriverId = Input::get('driver_id');
		$service = Service::find($inputServiceId);
		//dd($service);
		if ($service !== NULL) {
			$serviceStatusId = $service->status_id;
			if ($serviceStatusId == '6') {
				return Response::json(array('error' => '2'));
			}
			if ($service->driver_id == NULL && $serviceStatusId == '1') {
				Driver::update($inputDriverId, array(
					"available" => '0'
				));
				$driverTmp = Driver::find($inputDriverId);
				Service::update($inputServiceId, array(
							'driver_id' => $inputDriverId,
							'status_id' => '2',
							'car_id' => $driverTmp->car_id
							//Up Carro
							//'pwd' => md5(Input::get('pwd'))
				));
				//Notificar a usuario!!
				$pushMessage = 'Tu servicio ha sido confirmado!';
				$service = Service::find($inputServiceId);
				$push = Push::make();
				if ($service->user->uuid == '') {
					return Response::json(array('error' => '0'));
				}
				$serviceIdArray = array('serviceId' => $service->id);
				if ($service->user->type == '1') { //iPhone
					$result = $push->ios($service->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', $serviceIdArray);
				} else {
					$result = $push->android2($service->user->uuid, $pushMessage, 1, 'default', 'Open', $serviceIdArray);
				}
				return Response::json(array('error' => '0'));
			} else {
				return Response::json(array('error' => '1'));
			}
		} else {
			return Response::json(array('error' => '3'));
		}
	}
	/********* UNUSED OLD CODE VERSION FOR PUSH USER NOTIFICATION *********
	$service = Service::find($inputServiceId);
	$push = Push::make();
	if ($service->user->type == '1') { //iPhone
		$pushAns = $push->ios($service->user->uuid, $pushMessage);
	} else {
		$pushAns = $push->android($service->user->uuid, $pushMessage);
	}
	/********* UNUSED OLD CODE VERSION FOR PUSH USER NOTIFICATION **********/
?>