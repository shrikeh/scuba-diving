"use strict";

import {Item} from "@app/types/Kit/Item";

export interface KitBag {
  fetchItemDetails(slug: string): Array<Item>
}
