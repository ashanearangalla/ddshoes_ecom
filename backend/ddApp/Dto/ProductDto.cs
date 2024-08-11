namespace ddApp.Dto
{
    public class ProductDto
    {
        public int ProductID { get; set; }
        public string ProductName { get; set; }
        public string Description { get; set; }
        public decimal Price { get; set; }
        public bool IsLocked { get; set; } // Indicates if the product is locked for pre-orders
        public string ImageUrl { get; set; } // Path to the product image
    }
}
