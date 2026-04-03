<?php

namespace App\Validator;

use App\Entity\ExerciseAttempt;
use App\Validator\Constraint\ValidAttemptAnswer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidAttemptAnswerValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidAttemptAnswer) {
            throw new UnexpectedTypeException($constraint, ValidAttemptAnswer::class);
        }

        if (!$value instanceof ExerciseAttempt) {
            throw new UnexpectedValueException($value, ExerciseAttempt::class);
        }

        // Règle 1 — Si réussi coché mais la réponse est vide
        if ($value->isCorrect() === true && empty(trim($value->getAnswer() ?? ''))) {
            $this->context->buildViolation($constraint->emptyAnswerMessage)
                          ->atPath('answer')
                          ->addViolation();
        }

        // Règle 2 — Réponse trop longue
        if (strlen($value->getAnswer() ?? '') > $constraint->maxAnswerLength) {
            $this->context->buildViolation($constraint->tooLongMessage)
                          ->atPath('answer')
                          ->setParameter('{{ limit }}', (string) $constraint->maxAnswerLength)
                          ->addViolation();
        }

        // Règle 3 — Notes trop longues
        if (strlen($value->getNotes() ?? '') > $constraint->maxNotesLength) {
            $this->context->buildViolation($constraint->tooLongNotesMessage)
                          ->atPath('notes')
                          ->setParameter('{{ limit }}', (string) $constraint->maxNotesLength)
                          ->addViolation();
        }
    }
}
