class Usuario{
    constructor(usuario,email,senha, ID = this.geradorID()){
        this._usuario = usuario;
        this._email = email;
        this._senha = senha;
        this._ID = ID;
    }

    get usuario(){
        return this._usuario;
    }

    get email(){
        return this._email;
    }

    get senha(){
        return this._senha;
    }

    get ID(){
        return this._ID;
    }

    geradorID(){
        let caracteres = "AHMEQTYOPC";
        let id = "";
        for(let i = 0; i < 11; i++){
            id += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }
        return id;
    }
}