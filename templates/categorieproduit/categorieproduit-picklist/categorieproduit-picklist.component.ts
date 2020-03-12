import { Component, OnInit } from '@angular/core';
import { BamboAbstractPicklistComponent } from 'src/app/shared/components/bambo-abstract-picklist/bambo-abstract-picklist.component';
import { CategorieProduitService } from '../categorieproduit.service';
import { DialogService } from 'primeng/api';
import { CategorieProduitNewComponent } from '../categorieproduit-new/categorieproduit-new.component';
import { CategorieProduit } from '../categorieproduit';
import { ConnectionService } from 'ng-connection-service';

@Component({
  selector: 'app-categorieproduit-picklist',
  templateUrl: './categorieproduit-picklist.component.html',
  styleUrls: ['./categorieproduit-picklist.component.css'],
  providers: [DialogService]
})
export class CategorieProduitPicklistComponent extends BamboAbstractPicklistComponent implements OnInit {

  constructor(public categorieProduitSrv: CategorieProduitService, public dialogService: DialogService,
              public connectionService: ConnectionService) {
    super(categorieProduitSrv, connectionService);
  }

  ngOnInit() {
    super.ngOnInit();
  }

  openNewFormDialog() {
    const ref = this.dialogService.open(CategorieProduitNewComponent, {
      showHeader: false,
      closable: true,
      width: '90%',
      contentStyle: { 'max-height': '500px', overflow: 'auto' }
    });
    ref.onClose.subscribe((item: CategorieProduit) => {
      if (item) {
        this.items = [item, ...this.items];
        this.categorieProduitSrv.httpSrv.notificationSrv.success('Enregistrement créé avec succès');
      }
    });
  }

}
