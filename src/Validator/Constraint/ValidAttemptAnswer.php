<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class ValidAttemptAnswer extends Constraint
{
    public string $emptyAnswerMessage  = 'Tu as coché "J\'ai réussi" mais ta réponse est vide.';
    public string $tooLongMessage      = 'Ta réponse ne peut pas dépasser {{ limit }} caractères.';
    public string $tooLongNotesMessage = 'Les notes ne peuvent pas dépasser {{ limit }} caractères.';

    public int $maxAnswerLength = 10000;
    public int $maxNotesLength  = 2000;

    // Contrainte de classe qui valide l'objet entier
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
