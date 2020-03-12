import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Vente extends BamboObject {
    id: any;
                                montantInitial: string;
                                        montantRegle: string;
                                        montantRestant: string;
                                        dateLivraison: string;
                                        adresseLivraison: string;
                                        livree: string;
                                        regle: string;
                                        dateLivraisonPrevue: string;
                                        dateLivraisonEffective: string;
                                        type: string;
                                        date: string;
                                        numeroVente: string;
                        
    constructor() {
        super();
    }
}
