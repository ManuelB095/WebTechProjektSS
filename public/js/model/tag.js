class GalleryTagModel
{
    static _all = [];

    constructor(id, value)
    {
        GalleryTagModel._all.push(this);

        this._id = id;
        this._value = value;
        this._products = [];
    }

    get id()
    {
        return this._id;
    }

    get value()
    {
        return this._value;
    }

    addProduct(product)
    {
        this._products.push(product);
    }

    removeProduct(product)
    {
        for(var i = this._products.length-1; i >= 0; --i)
        {
            if(this._products[i] == product)
            {
                //TODO get the slice thing from commit history
            }
        }
    }

    static GetModelByID(id)
    {
        for(var i = this._all.length -1; i >= 0; --i)
        {
            if( this._all[i].id == id )
            {
                return this._all[i];
            }
        }
    }

    static RemoveAll()
    {
        for(var i = this._all.length -1; i >= 0; --i)
        {
            delete this._all[i];
        }
        this._all = [];
    }
}
