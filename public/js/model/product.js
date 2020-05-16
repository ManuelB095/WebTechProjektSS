class GalleryProductModel
{
    static _all = [];

    constructor(id, owner, geodata)
    {
        GalleryProductModel._all.push(this);

        this._id = id;
        this._owner = owner;
        this._access = 0; //TODO
        this._geodata = geodata;
        this._tags = [];
    }
    
    get id()
    {
        return this._id;
    }

    get owner()
    {
        return this._owner;
    }

    get access()
    {
        return this._access;
    }

    get geodata()
    {
        return this._geodata;
    }

    addTag(tag)
    {
        this._tags.push(tag);
    }

    removeTag(tag)
    {
        for(var i = this._tags.length-1; i >= 0; --i)
        {
            if(this._tags[i] == tag)
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
