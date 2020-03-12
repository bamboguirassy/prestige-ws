import { BamboObject } from 'src/app/shared/interfaces/bambo-object';

export class Modele extends BamboObject {
    id: any;
                                nom: string;
                                        description: string;
                                        photo: string;
                        
    constructor() {
        super();
    }
}
