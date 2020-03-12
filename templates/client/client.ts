import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Client extends BamboObject {
    id: any;
                                prenom: string;
                                        nom: string;
                                        telephone: string;
                                        email: string;
                                        fonction: string;
                                        adresse: string;
                        
    constructor() {
        super();
    }
}
