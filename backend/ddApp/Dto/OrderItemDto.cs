namespace ddApp.Dto
{
    public class OrderItemDto
    {
        public int OrderItemID { get; set; }
        public int OrderID { get; set; } // Foreign key to Order
        public int ProductID { get; set; } // Foreign key to Product
        public int Quantity { get; set; }
    }
}
