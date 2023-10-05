<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\FormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;  //submittype form
use Symfony\Component\Form\Extension\Core\Type\FileType;  //filetype form
use Symfony\Component\Validator\Constraints\File;  //constraints for file


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
           /* ->add('userImage', FileType::class,[
                'mapped' => false
            ])*/
            ->add('avatar', FileType::class,[
                'mapped' => false
            ])  //https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service
            ->add('attachment', FileType::class,[
                'label' =>'Profile (PDF file)',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' =>'1024k',
                        'extensions' => ['pdf','docx','txt','xml'],
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'text/plain',
                            'text/xml',
                            'application/xml'
                        ],
                        'mimeTypesMessage' =>'Please upload a valid Document',
                    ])
                ],
            ])
           // ->add('userid')
            ->add('email')
            ->add('department') /*, EntityType::class,[
                'class' => Department::class
            ]) */   //to render object as text user _string function in department.php
            ->add('Save', SubmitType::class,[
                'attr'=> ['class'=> 'btn btn-primary float-end']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
