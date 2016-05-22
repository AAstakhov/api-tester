<?php


namespace Aa\ApiTester\ApiTest;


use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationListFormatter
{
    /**
     * @param ConstraintViolationListInterface $violations
     * @param TestMetadata                     $testMetadata
     *
     * @return string
     */
    public function format(ConstraintViolationListInterface $violations, TestMetadata $testMetadata)
    {
        $messages = '';

        $messages[] .= sprintf('Test file: %s', $testMetadata->getFile()->getRealPath());
        $messages[] .= sprintf('Test name: %s', $testMetadata->getTestName());

        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $constraint = $violation->getConstraint();
            $messages[] = sprintf('    %s: %s', $violation->getPropertyPath(), $violation->getMessage());
            if($invalidValue = $violation->getInvalidValue()) {
                $messages[] = sprintf('        Actual:   %s', $invalidValue     );
            }

            if(null !== $constraint) {
                $messages[] = sprintf('        Constraint: %s', $constraint->validatedBy());

                $constraintOptions = [$constraint->getDefaultOption()] + $constraint->getRequiredOptions();
                foreach ($constraintOptions as $option) {
                    $messages[] = sprintf('            %s: %s', $option, $constraint->$option);
                }
            }
        }

        $messages[] = '';

        return implode(PHP_EOL, $messages);
    }
}
