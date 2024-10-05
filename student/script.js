document.addEventListener('DOMContentLoaded', () => {
    fetchCategories();
});

/*function fetchCategories() {
    fetch('get_categories.php')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('categorySelect');
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });
}

function filterProducts() {
    const categoryId = document.getElementById('categorySelect').value;
    fetch(`get_products.php?category_id=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';
            data.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.classList.add('product');
                productDiv.textContent = product.name;
                productList.appendChild(productDiv);
            });
        });
}
*/
function fetchuseravailability() {
    fetch('get_categories.php')
    .then(response => response.json())
        .then(data => {
            const timeSlotSelect= document.getElementById('categorySelect');
            data.forEach(category =>{
                const option = document.createElement('option1');
                option1.value = category.user_id;
                option1.textContent= category.time_slot;
                categorySelect.appendChlid(option1);
            });
        });
}

function filterUsers() {
    const useravailabilityId = document.getElementById('categorySelect').value;
    fetch(`get_product.php'?id=${useravailabilityId}`)
    .then(response => response.json())
        .then(data => {
            const userList = document.getElementById('userList');
            userList.innerHTML = '';
            data.forEach(product =>{
                const userDiv= document.createElement('div');
                userDiv.classList.add('product');
                userDiv.textContent = users.full_name;
                userList.appendChild(userDiv);
                
            });
        });
            
}






