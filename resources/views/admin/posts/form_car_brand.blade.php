<div class="container" style="display: flex; justify-content: space-between; gap: 100px; align-items: center;">
    <div class="row g-1" style="background-color: grey; padding: 20px 30px 30px 30px; border-radius: 5px; color: white;">
        <label for="brand_name" class="form-label">Brand Name</label>
        <input type="text" class="form-control" id="brand_name" name="brand_name" style="border-color: black; margin-bottom: 10px;" required>
        <label for="brand_name" class="form-label">Re-type Car Brand Name</label>
        <input type="text" class="form-control" id="r-type_brand_name" name="r-type_brand_name" required>
        <div class="col-md-12" style="text-align: right; padding-top:10px;">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

    <div class="" style="color: white;">
        <label for="brand_name" class="form-label">Upload Brand Logo</label>
        <div class="container-fluid" style="text-align: center; background-color: #363636; height: 250px; width: 300px; border-radius: 5px; border: 2px solid orange">
            <img class="mt-3" src="" alt="image logo" width="374px" height="341px" >
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <label for="file_logo" class="btn btn-primary">
                Choose Logo
                <input type="file" id="file_logo" name="file_logo" required style="display: none;">
            </label>
        </div>
    </div>
</div>
