<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EquipmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('name')->setLabel('Nom équipement'),
            BooleanField::new('available')->setLabel('Disponibilité'),
            DateTimeField::new('created_at')->setLabel('En stock depuis :'),
            TextEditorField::new('description'),
            AssociationField::new('state_id')->setLabel('État'),
            AssociationField::new('type_id')->setLabel('type'),
            TextField::new('reference')->setLabel('Référence de l\'équipement')
        ];
    }
}
