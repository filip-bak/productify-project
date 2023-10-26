export class ProductAddError extends Error {
  constructor(message, status) {
    super(message);
    this.name = 'ProductAddError';
    this.status = status;
  }
}
