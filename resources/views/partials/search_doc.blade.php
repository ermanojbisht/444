<form method="post" name="forwadfrm" action="{{route($formaction) }}" class="row p-2 g-3 align-items-center"> 
    {{ csrf_field() }}
    <input type="hidden" name="{{$fieldName}}" value="{{ $fieldValue }}">
    <div class="col-auto">
        <label for="searchBox" class="col-form-label fw-bold">Search Documents By Type</label>
    </div>
    <div class="col-auto">
        <select name="doctype" id="searchBox" class="form-control">
            <option value="0" @if($doctypeid == 0) selected @endif>All Document Type</option>
            @foreach($docTypes as $docType)
                <option value="{{ $docType->id }}"
                        @if($docType->id == $doctypeid) selected @endif>{{ $docType->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
            <button type="submit" name="submit" class="btn btn-outline-info">
                Search
            </button>
    </div>
</form>