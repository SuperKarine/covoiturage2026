<?php

namespace Entity;


enum TypeTransaction: string
{
    case DEBIT  = 'debit';
    case CREDIT = 'credit';
}