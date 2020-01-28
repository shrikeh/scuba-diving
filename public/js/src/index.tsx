'use strict';

import * as React from "react";
import { render } from "react-dom";
import { Item } from "@app/components/Kit/Item";

const domContainer = document.querySelector('#scuba-diving');

render(
  <Item />,
  domContainer
);
