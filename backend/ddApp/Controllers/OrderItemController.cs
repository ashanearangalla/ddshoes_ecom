using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class OrderItemController : ControllerBase
    {
        private readonly IOrderItemRepository _orderItemRepository;
        private readonly IMapper _mapper;

        public OrderItemController(IOrderItemRepository orderItemRepository, IMapper mapper)
        {
            _orderItemRepository = orderItemRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<OrderItemDto>))]
        public IActionResult GetOrderItems()
        {
            var orderItems = _mapper.Map<List<OrderItemDto>>(_orderItemRepository.GetOrderItems());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(orderItems);
        }

        [HttpGet("{orderItemId}")]
        [ProducesResponseType(200, Type = typeof(OrderItemDto))]
        [ProducesResponseType(400)]
        public IActionResult GetOrderItem(int orderItemId)
        {
            if (!_orderItemRepository.OrderItemExists(orderItemId))
                return NotFound();

            var orderItem = _mapper.Map<OrderItemDto>(_orderItemRepository.GetOrderItem(orderItemId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(orderItem);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreateOrderItem([FromBody] OrderItemDto orderItemCreate)
        {
            if (orderItemCreate == null)
                return BadRequest(ModelState);

            var orderItem = _orderItemRepository.GetOrderItems()
                .Where(o => o.OrderItemID == orderItemCreate.OrderItemID)
                .FirstOrDefault();

            if (orderItem != null)
            {
                ModelState.AddModelError("", "OrderItem already exists");
                return StatusCode(422, ModelState);
            }

            var orderItemMap = _mapper.Map<OrderItem>(orderItemCreate);

            if (!_orderItemRepository.CreateOrderItem(orderItemMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{orderItemId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateOrderItem(int orderItemId, [FromBody] OrderItemDto updatedOrderItem)
        {
            if (updatedOrderItem == null || orderItemId != updatedOrderItem.OrderItemID)
                return BadRequest(ModelState);

            if (!_orderItemRepository.OrderItemExists(orderItemId))
                return NotFound();

            var orderItemMap = _mapper.Map<OrderItem>(updatedOrderItem);

            if (!_orderItemRepository.UpdateOrderItem(orderItemMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{orderItemId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeleteOrderItem(int orderItemId)
        {
            if (!_orderItemRepository.OrderItemExists(orderItemId))
                return NotFound();

            var orderItem = _orderItemRepository.GetOrderItem(orderItemId);

            if (!_orderItemRepository.DeleteOrderItem(orderItem))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }
    }
}
