import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Produit extends BamboObject {
    id: any;
                                nom: string;
                                        prixMinimum: string;
                                        prixVariable: string;
                                        quantifiable: string;
                                        quantiteDisponible: string;
                                        expose: string;
                                        description: string;
                                        type: string;
                        
    constructor() {
        super();
    }
}
