<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@officeLog', dirname(dirname(__DIR__)) . '/backend/runtime/logs/' . date('Ymd') . '.log');
Yii::setAlias('@frontendLog', dirname(dirname(__DIR__)) . '/frontend/runtime/logs/' . date('Ymd') . '.log');
Yii::setAlias('@node', dirname(dirname(__DIR__)) . '/node_modules');
